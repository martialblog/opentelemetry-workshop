from flask import Flask, redirect, url_for, render_template, request
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.orm import DeclarativeBase
from sqlalchemy.orm import Mapped, mapped_column


class Base(DeclarativeBase):
    pass


app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///db.sqlite'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(model_class=Base)
db.init_app(app)


class Item(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    title: Mapped[str]
    description: Mapped[str]


@app.route('/todo/new', methods=['POST'])
def todo_api_post_new():
    title = request.form['title']
    description = request.form['description']

    if title == "":
        return redirect(url_for('todo_get_all'))

    item = Item(title=title, description=description)

    db.session.add(item)
    db.session.commit()

    return redirect(url_for('todo_get_all'))


@app.route('/todo/delete/<int:id>', methods=['POST'])
def todo_api_delete_by_id(id):
    item = db.get_or_404(Item, id)
    db.session.delete(item)
    db.session.commit()

    return redirect(url_for('todo_get_all'))


@app.route('/todo/<int:id>', methods=['GET'])
def todo_api_get_by_id(id):
    item = db.get_or_404(Item, id)
    return render_template('item_show.html', item=item)


@app.route('/todo/all', methods=['GET'])
def todo_get_all():
    items = db.session.execute(db.select(Item).order_by(Item.title)).scalars()
    return render_template('index.html', items=items)


@app.route('/todo/new', methods=['GET'])
def todo_create_new():
    return render_template('item_create.html')


@app.route('/', methods=['GET'])
def todo_index():
    return redirect(url_for('todo_get_all'))


if __name__ == '__main__':
    with app.app_context():
        db.create_all()

    app.run(debug=True)
