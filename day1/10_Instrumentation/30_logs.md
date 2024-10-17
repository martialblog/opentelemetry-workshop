!SLIDE

# ~~~SECTION:MAJOR~~~.~~~SECTION:MINOR~~~ Logs

OpenTelemetry does not define a bespoke API or SDK to create logs.

OpenTelemetry’s support for logs is designed to be compatible with what you already have.

The `Log Bridge API` can be used by logging library authors to integrade with OpenTelemetry.

It should not be called by you the user.

!SLIDE

# Auto Instrumentation

Depending on the logging library you are using:

    @@@Sh
    pip install opentelemetry-exporter-{exporter}
    pip install opentelemetry-instrumentation-{instrumentation}

    # Example:
    pip install opentelemetry-instrumentation-logging

See: https://opentelemetry.io/ecosystem/registry/

!SLIDE

# Manual Log Instrumentation

Just an example, we don't need to do this manually:

    @@@Python
    import logging
    from opentelemetry.instrumentation.logging import (
    DEFAULT_LOGGING_FORMAT, LoggingInstrumentor )

    LoggingInstrumentor().instrument(
      set_logging_format=True,
      log_level=logging.DEBUG
    )

    logging.debug('Debug me')
    logging.info('Info only')
    logging.warning('Dangerzone!')

More on zero code instrumentation later.

See: Lab 3.1

!SLIDE

# Log Record

Resource and attributes fields of arbitrary value and type

Named top-level fields of specific type and meaning

* Timestamp, Time when the event occurred.
* SeverityText, The severity text (also known as log level).
* SeverityNumber, Numerical value of the severity.
* Body, The body of the log record.

Existing log formats should be unambiguously mapped to this data model.
