# DAES

Minimal Flask scaffold to run the DAES web app.

How to run locally

1. Create and activate a virtual environment:

   python -m venv venv
   source venv/bin/activate   # macOS/Linux
   venv\Scripts\activate    # Windows

2. Install dependencies:

   pip install -r requirements.txt

3. Run locally:

   export PORT=5000        # macOS/Linux
   set PORT=5000           # Windows (PowerShell: $env:PORT=5000)
   python app.py

Deploy on Render

- Connect your GitHub account to Render and grant access to this repo (private repos allowed).
- Create a new Web Service, select branch `main`.
- Build command: `pip install -r requirements.txt`
- Start command: `gunicorn app:app --bind 0.0.0.0:$PORT`

Or use the included Dockerfile and select Docker on Render.
