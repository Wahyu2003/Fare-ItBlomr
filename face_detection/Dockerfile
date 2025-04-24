FROM python:3.9-slim

ENV PYTHONUNBUFFERED=1

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    cmake \
    libopenblas-dev \
    liblapack-dev \
    libx11-dev \
    libgtk-3-dev \
    libatlas-base-dev \
    libboost-python-dev \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Copy all files
COPY . .

# Upgrade pip and install required packages
RUN pip install --no-cache-dir --upgrade pip
RUN pip install --no-cache-dir flask face_recognition flask_cors requests

# Expose API port
EXPOSE 5000

# Start the app
CMD ["python", "face_detection_api.py"]
