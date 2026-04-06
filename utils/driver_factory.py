import logging
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
from webdriver_manager.firefox import GeckoDriverManager
from utils.config import cfg


def create_driver():
    if cfg.BROWSER.lower() == "firefox":
        from selenium.webdriver.firefox.options import Options as FFOptions
        opts = FFOptions()
        if cfg.HEADLESS:
            opts.headless = True
        driver = webdriver.Firefox(service=Service(GeckoDriverManager().install()), options=opts)
        driver.maximize_window()
        return driver

    # default chrome
    options = Options()
    if cfg.HEADLESS:
        options.add_argument("--headless=new")
    options.add_argument("--no-sandbox")
    options.add_argument("--disable-dev-shm-usage")
    options.add_argument("--window-size=1920,1080")

    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service, options=options)
    driver.maximize_window()
    return driver
