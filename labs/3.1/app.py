import logging

from opentelemetry.instrumentation.logging import DEFAULT_LOGGING_FORMAT, LoggingInstrumentor

LoggingInstrumentor().instrument(set_logging_format=True, log_level=logging.DEBUG)
LoggingInstrumentor(set_logging_format=True)
logging.basicConfig(level=logging.DEBUG)

logging.debug('This message should appear on the console')
logging.info('So should this')
logging.warning('And this, too')
