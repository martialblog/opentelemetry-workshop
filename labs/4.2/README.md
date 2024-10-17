# Example Python Application

See: labs/examples/py-todo

Setup:

```
pip install -r requirements.txt

pip install opentelemetry-distro opentelemetry-exporter-otlp

opentelemetry-bootstrap -a install

export OTEL_PYTHON_LOGGING_AUTO_INSTRUMENTATION_ENABLED=true
```

Examples:

```
opentelemetry-instrument --traces_exporter=None --metrics_exporter=None --logs_exporter=None --service_name=todoapp python app.py

opentelemetry-instrument --traces_exporter=None --metrics_exporter=None --logs_exporter=console --service_name=todoapp python app.py

opentelemetry-instrument --traces_exporter=console --metrics_exporter=console --logs_exporter=console --service_name=todoapp python app.py

opentelemetry-instrument --traces_exporter=otlp --metrics_exporter=otlp --logs_exporter=otlp --service_name=todoist python app.py
```
