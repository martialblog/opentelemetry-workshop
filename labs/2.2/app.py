import time

from opentelemetry.sdk.resources import Resource

from opentelemetry import trace
from opentelemetry.sdk.trace import TracerProvider
from opentelemetry.sdk.trace.export import (
    BatchSpanProcessor,
    ConsoleSpanExporter,
)

resource = Resource.create({"service.name": "mytrace"})

trace.set_tracer_provider(TracerProvider(resource=resource))

trace.get_tracer_provider().add_span_processor(
    BatchSpanProcessor(ConsoleSpanExporter())
)

tracer = trace.get_tracer(__name__)

def do_stuff():
    time.sleep(1)

with tracer.start_as_current_span("root") as root_span:
    do_stuff()
    with tracer.start_as_current_span("child") as child_span:
        child_span.add_event("message", {"foo": "bar"})
        do_stuff()
