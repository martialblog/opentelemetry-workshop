import random
import time

from opentelemetry import metrics

from opentelemetry.sdk.resources import Resource

from opentelemetry.metrics import Observation

from opentelemetry.sdk.metrics import MeterProvider
from opentelemetry.sdk.metrics.export import ConsoleMetricExporter, PeriodicExportingMetricReader

from http.server import HTTPServer, BaseHTTPRequestHandler

resource = Resource.create({'service.name': 'myapp'})

exporter = ConsoleMetricExporter()
reader = PeriodicExportingMetricReader(exporter=exporter, export_interval_millis=5000)
provider = MeterProvider(metric_readers=[reader], resource=resource)

metrics.set_meter_provider(provider)

mymeter = metrics.get_meter('mymeter')

# For possible units see https://unitsofmeasure.org/ucum
class Device:
    def __init__(self, meter, name):
        self.name = name
        gauge = meter.create_observable_gauge(name='thermometer',
                                              unit='celcius',
                                              callbacks=[lambda options: [Observation(value=random.randint(-10,10))]])

d = Device(mymeter, 'My Example Device')

time.sleep(60)
