!SLIDE

# Zero Code Instrumentation

The opentelemetry-distro package installs the API, SDK, and the opentelemetry-bootstrap and opentelemetry-instrument tools:

    @@@Sh
    pip install opentelemetry-distro opentelemetry-exporter-otlp
    opentelemetry-bootstrap -a install

    opentelemetry-instrument --service_name myapp \
    --traces_exporter console \
    --logs_exporter console \
    --metrics_exporter console \
    python myapp.py

See: Lab 3.2
