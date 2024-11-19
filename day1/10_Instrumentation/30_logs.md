!SLIDE

# ~~~SECTION:MAJOR~~~.~~~SECTION:MINOR~~~ Logs

OpenTelemetry does not define an API or SDK to create logs, only a data model.

OpenTelemetry's support for logs is designed to be compatible with what you already have.

The `Log Bridge API` can be used by logging library authors to integrate with OpenTelemetry.

It should not be called by you the user.

!SLIDE

# Log Record

The data model:

* Resource: describes the source of the log
* Timestamp: time when the event occurred
* SeverityText: the severity text (also known as log level)
* SeverityNumber: numerical value of the severity
* Body: the body of the log record
* Attributes: additional information about the event

Existing log formats should be mapped to this data model.

See: https://opentelemetry.io/docs/specs/otel/logs/data-model/

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

See: Lab 3.1
