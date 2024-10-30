import random

from opentelemetry.sdk.resources import Resource

from opentelemetry import metrics

from opentelemetry.sdk.metrics.view import ExplicitBucketHistogramAggregation, View
from opentelemetry.sdk.metrics import MeterProvider
from opentelemetry.sdk.metrics.export import ConsoleMetricExporter, PeriodicExportingMetricReader

resource = Resource.create({'service.name': 'myapp'})

# Bucket upper-bounds are inclusive (except for the case where the upper-bound is +Inf) while bucket lower-bounds are exclusive.
# That is, buckets express the number of values that are greater than their lower bound and less than or equal to their upper bound.
bucket_boundaries = list(range(1,7))

view = View(
    instrument_name='dice.rolls',
    name='dice.rolls.view',
    aggregation=ExplicitBucketHistogramAggregation(boundaries=bucket_boundaries)
)

exporter = ConsoleMetricExporter()
reader = PeriodicExportingMetricReader(exporter)
provider = MeterProvider(metric_readers=[reader], views=[view], resource=resource)

metrics.set_meter_provider(provider)

mymeter = metrics.get_meter(name='dice.meter')

histogram = mymeter.create_histogram(name='dice.rolls', unit='count', description='1D6 Dice Rolls')

# Fill the histogram
for r in range(1,100):
    i = random.randint(1, 6)
    histogram.record(i)
