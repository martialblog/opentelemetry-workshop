from opentelemetry import metrics

from opentelemetry.sdk.resources import Resource

from opentelemetry.sdk.metrics import MeterProvider
from opentelemetry.sdk.metrics.export import ConsoleMetricExporter, PeriodicExportingMetricReader

from http.server import HTTPServer, BaseHTTPRequestHandler

resource = Resource.create({'service.name': 'myapp'})

exporter = ConsoleMetricExporter()
reader = PeriodicExportingMetricReader(exporter=exporter, export_interval_millis=10000)
provider = MeterProvider(metric_readers=[reader], resource=resource)

metrics.set_meter_provider(provider)

mymeter = metrics.get_meter(name='inventory.meter')
inventory_counter = mymeter.create_up_down_counter('inventory_counter')

# Simple HTTP server to adjust the counter
# curl localhost:8000/dec
# url localhost:8000/add
class SimpleHTTPRequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        if self.path == '/add':
            self.send_response(200)
            self.end_headers()
            inventory_counter.add(1)
            self.wfile.write(b'Added one!\n')
            return

        if self.path == '/dec':
            self.send_response(200)
            self.end_headers()
            inventory_counter.add(-1)
            self.wfile.write(b'Remove one!\n')
            return

        self.send_response(404)
        self.end_headers()
        self.wfile.write(b'Not found\n')

httpd = HTTPServer(('', 8000), SimpleHTTPRequestHandler)
httpd.serve_forever()
