# Example Python Application

Setup:

```
pip install opentelemetry-distro opentelemetry-exporter-otlp

opentelemetry-bootstrap -a install

export OTEL_PYTHON_LOGGING_AUTO_INSTRUMENTATION_ENABLED=true
```

Examples:

```
opentelemetry-instrument --traces_exporter=console --metrics_exporter=console --logs_exporter=console --service_name=myapp flask run
```
