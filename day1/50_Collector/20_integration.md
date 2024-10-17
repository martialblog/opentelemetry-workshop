!SLIDE

# Integration

`opentelemetry-instrument` is a tool that automatically instruments code
via available instrumentation libraries:

    @@@Sh
    pip install opentelemetry-distro opentelemetry-exporter-otlp
    opentelemetry-bootstrap -a install

    export OTEL_PYTHON_LOGGING_AUTO_INSTRUMENTATION_ENABLED=true

    opentelemetry-instrument --traces_exporter=console \
    --metrics_exporter=console \
    --logs_exporter=console --service_name=dice flask run

Hint: Differs depending on the language. https://opentelemetry.io/docs/concepts/instrumentation/zero-code/

See: Lab 4.2
