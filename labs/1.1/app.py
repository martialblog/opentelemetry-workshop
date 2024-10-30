import random

from opentelemetry import metrics
from opentelemetry.sdk.resources import Resource
from opentelemetry.sdk.metrics import MeterProvider
from opentelemetry.sdk.metrics.export import ConsoleMetricExporter, PeriodicExportingMetricReader

# A Resource is an immutable representation of the entity producing telemetry
resource = Resource.create({"service.name": "myapp"})

# Implementation of :class:`MetricExporter` that prints metrics to the console
exporter = ConsoleMetricExporter()

# Collects metrics based on a user-configurable time interval, and passes them to the exporter
reader = PeriodicExportingMetricReader(exporter)

provider = MeterProvider(metric_readers=[reader], resource=resource)
metrics.set_meter_provider(provider)

# Get a Meter from the MeterProvider
mymeter = metrics.get_meter(name="dice.meter")

# Create a Counter instrument on the Meter
roll_counter = mymeter.create_counter(
    "dice.rolls",
    unit="count",
    description="Count dice rolls by value"
)

# Add values to the Counter
for r in range(1,10):
    roll_counter.add(1, {"roll.result": random.randint(1, 6)})
