from flask import Flask, request, jsonify
import sqlite3
import os

app = Flask(__name__)
DB_PATH = 'votes.db'

# Initialize DB
if not os.path.exists(DB_PATH):
    conn = sqlite3.connect(DB_PATH)
    c = conn.cursor()
    c.execute('''
        CREATE TABLE votes (
            post_id TEXT PRIMARY KEY,
            content TEXT,
            author TEXT,
            upvotes INTEGER DEFAULT 0,
            downvotes INTEGER DEFAULT 0
        )
    ''')
    conn.commit()
    conn.close()

def get_conn():
    return sqlite3.connect(DB_PATH)

@app.route('/vote', methods=['POST'])
def add_post():
    data = request.get_json()
    
    # Validate required fields
    if not data:
        return jsonify({'error': 'No JSON data provided'}), 400
    
    required_fields = ['post_id', 'content', 'author']
    missing_fields = [field for field in required_fields if field not in data]
    
    if missing_fields:
        return jsonify({'error': f'Missing required fields: {", ".join(missing_fields)}'}), 400
    
    # Validate that fields are not empty or null
    empty_fields = []
    for field in required_fields:
        value = data[field]
        # Check for None or empty strings (post_id can be numeric, content and author should be strings)
        if value is None:
            empty_fields.append(field)
        elif isinstance(value, str) and value.strip() == '':
            empty_fields.append(field)
    
    if empty_fields:
        return jsonify({'error': f'Fields cannot be empty: {", ".join(empty_fields)}'}), 400
    
    post_id = str(data['post_id'])
    content = data['content']
    author = data['author']

    conn = get_conn()
    c = conn.cursor()
    c.execute('INSERT OR IGNORE INTO votes (post_id, content, author) VALUES (?, ?, ?)',
              (post_id, content, author))
    conn.commit()
    conn.close()
    return jsonify({'status': 'ok'})

@app.route('/vote/<post_id>', methods=['POST'])
def vote(post_id):
    data = request.get_json()
    
    if not data:
        return jsonify({'error': 'No JSON data provided'}), 400
    
    direction = data.get('direction')
    if direction is None:
        return jsonify({'error': 'Missing direction field'}), 400
    if direction not in ['up', 'down']:
        return jsonify({'error': 'Invalid direction value'}), 400

    conn = get_conn()
    c = conn.cursor()
    if direction == 'up':
        c.execute('UPDATE votes SET upvotes = upvotes + 1 WHERE post_id = ?', (post_id,))
    else:
        c.execute('UPDATE votes SET downvotes = downvotes + 1 WHERE post_id = ?', (post_id,))
    conn.commit()
    conn.close()
    return jsonify({'status': 'ok'})

@app.route('/results/<post_id>')
def results(post_id):
    conn = get_conn()
    c = conn.cursor()
    c.execute('SELECT upvotes, downvotes FROM votes WHERE post_id = ?', (post_id,))
    row = c.fetchone()
    conn.close()
    if row:
        return jsonify({'upvotes': row[0], 'downvotes': row[1]})
    return jsonify({'upvotes': 0, 'downvotes': 0})
    
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
