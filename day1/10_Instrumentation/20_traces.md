!SLIDE

# ~~~SECTION:MAJOR~~~.~~~SECTION:MINOR~~~ Traces

The components that we use in our code:

* A `Trace Provider` is a factory for Tracers
* A `Tracer` creates `Spans` containing more information about what is happening for a given operation
* `Trace Exporters` send trace data to a consumer

!SLIDE

# Manual Trace Instrumentation

Simple example for a Python instrument:

    @@@Python
    tracer = trace.get_tracer("mytracer")

    with tracer.start_as_current_span("foo"):
        do_stuff()

Similar in Golang:

    @@@Go
	ctx, span := tracer.Start(r.Context(), "roll")
	defer span.End()

    roll := 1 + rand.Intn(6)

	rollValueAttr := attribute.Int("roll.value", roll)
	span.SetAttributes(rollValueAttr)

See: Lab 2.1

!SLIDE

# Span

A span represents a unit of work or operation. Spans are the building blocks of Traces.

* Name
* Parent span ID (empty for root spans)
* Span Links, associate one span with one or more spans, implying a causal relationship.
* Span Context
* Span Events, like a structured log message
* Span Status, possible values: Unset, Error, Ok
* Attributes
* Start and End Timestamps

!SLIDE

# Span Events

Events are like structured log message (or annotation) on a Span,
typically used to denote a singular point in time during the Span's duration.

For example, consider two scenarios in a browser:

1. Tracking a page load
2. Denoting when a page becomes interactive

The first scenario has a clear start and end, thus a Span.

The second is a singular point in time, thus a Span Event.

See: Lab 2.2 and Lab 2.3
