import random
import logging
from collections import namedtuple

from flask import Flask, request, Response

logging.basicConfig(level=logging.DEBUG)

app = Flask(__name__)

Dice = namedtuple('Dice', ['amount', 'faces'])

def roll(dice):
    logging.debug('start dice roll')
    summary = 0
    for roll in range (0, dice.amount):
        summary += random.randint(1, dice.faces)
    logging.debug('end dice roll')
    return summary

def parse_dice_type(dice_type):
    """
    Parse dice types (1D20, 2D6, 5D4) into a tuple of dice count and dice type
    """
    a, f = dice_type.lower().split('d')
    if not a.isdigit() or not f.isdigit():
        logging.error('Dice parsing error')
        raise ValueError('Dice parsing error')
    return Dice(int(a), int(f))

@app.route('/roll')
def roll_dice():
    logging.info('start rolling')
    dice_type = request.args.get('dice', default=None, type=str)
    dice = None
    try:
        dice = parse_dice_type(dice_type)
    except ValueError:
        logging.warning('error while rolling')
        return Response(result, status=400)

    result = roll(dice)
    logging.info('end rolling')
    return Response(f"{result}\n", status=200)

# curl "localhost:5000/roll?dice=1d20"
# curl "localhost:5000/roll?dice=2d4"
if __name__ == '__main__':
    app.run(debug=True)
