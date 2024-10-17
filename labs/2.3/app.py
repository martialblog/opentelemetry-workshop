import random
from collections import namedtuple

from flask import Flask, request, Response

from opentelemetry.sdk.resources import Resource

from opentelemetry import trace
from opentelemetry.sdk.trace import TracerProvider
from opentelemetry.sdk.trace.export import BatchSpanProcessor, ConsoleSpanExporter

resource = Resource.create({"service.name": "roller"})

exporter = ConsoleSpanExporter()
processor = BatchSpanProcessor(exporter)

trace.set_tracer_provider(TracerProvider(resource=resource))
trace.get_tracer_provider().add_span_processor(processor)

app = Flask(__name__)

Dice = namedtuple('Dice', ['amount', 'faces'])

def roll(dice):
    summary = 0
    for roll in range (0, dice.amount):
        summary += random.randint(1, dice.faces)
    return summary

def parse_dice_type(dice_type):
    """
    Parse dice types (1D20, 2D6, 5D4) into a tuple of dice count and dice type
    """
    a, f = dice_type.lower().split("d")
    if not a.isdigit() or not f.isdigit():
        raise ValueError("Dice parsing error")
    return Dice(int(a), int(f))

@app.route("/roll")
def roll_dice():
    dice_type = request.args.get('dice', default=None, type=str)
    dice = None
    try:
        dice = parse_dice_type(dice_type)
    except ValueError:
        return Response(result, status=400)

    result = roll(dice)
    return Response(f"{result}\n", status=200)
