!SLIDE

# ~~~SECTION:MAJOR~~~.~~~SECTION:MINOR~~~ Metrics

The components that we use in our code:

* A `Meter Provider` is a factory for Meters
* A `Meter` creates `Metric Instruments`, these instruments capture the actual measurements
* `Metric Exporters` send metric data to a consumer

!SLIDE

# Manual Metric Instrumentation

Dependencies for instrumentation:

    @@@Sh
    pip install opentelemetry-api
    pip install opentelemetry-sdk

Simple example for an instrument:

    @@@Python
    mymeter = metrics.get_meter(name="dice.meter")

    roll_counter = mymeter.create_counter(
        "dice.rolls",
        unit="count",
        description="The number of rolls by roll value"
    )

See: Lab 1.1 and Lab 1.2

!SLIDE

# Synchronous Instruments

These are invoked together with operations they are measuring.

* `Counter`, supports non-negative increments
* `UpDownCounter`, supports increments and decrements.
* `Histogram` can be used to report arbitrary values that are likely to be statistically meaningful

See: Lab 1.3

!SLIDE

# Asynchronous Instruments

These are periodically invoke a callback function to collect measurements.

* `ObservableCounter`, reports monotonically increasing values when the instrument is being observed
* `ObservableUpDownCounter`, additive values when the instrument is being observed
* `Asynchronous Gauge`, reports non-additive values when the instrument is being observed (e.g. a temperature)

See: Lab 1.4

!SLIDE

# Views and Aggregations

Aggregations are the means by which metric events are processed. Example: SumAggregation, LastValueAggregation, ExplicitBucketHistogramAggregation

The OpenTelemetry API provides a default aggregation for each instrument which can be overridden using a View.

    @@@Python
    view = View(
      instrument_name="myhist*",
      aggregation=ExplicitBucketHistogramAggregation(boundaries=[1,2,3,4])
    )

    provider = MeterProvider(metric_readers=[reader], views=[view])

!SLIDE

# Exporters

Exporters are responsible to send the collected data elsewhere:

* ConsoleMetricExporter: used to write debug messages to the console
* OTLPMetricExporter: push metrics to any device that understands the OpenTelemetry protocol
* Prometheus Metric Exporter: pull-based exporter that Prometheus clients can scrape
* Prometheus Remote Write Exporter: push-based exporter for the Prometheus remote write protocol

<!-- -->

    @@@Python
    exporter = OTLPMetricExporter(insecure=True)
    reader = PeriodicExportingMetricReader(exporter)
    provider = MeterProvider(metric_readers=[reader])

More on OTLP later.
