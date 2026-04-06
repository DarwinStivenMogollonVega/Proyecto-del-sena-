import os


class Config:
    BASE_URL = os.environ.get("BASE_URL", "http://localhost:8000")
    TIMEOUT = int(os.environ.get("SELENIUM_TIMEOUT", "10"))
    HEADLESS = os.environ.get("HEADLESS", "0") == "1"
    BROWSER = os.environ.get("BROWSER", "chrome")


cfg = Config()
