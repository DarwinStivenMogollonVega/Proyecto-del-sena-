from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException


class BasePage:
    def __init__(self, driver, base_url: str, timeout: int = 10):
        self.driver = driver
        self.base_url = base_url
        self.wait = WebDriverWait(driver, timeout)

    def open(self, path: str = "/"):
        url = self.base_url.rstrip("/") + path
        self.driver.get(url)

    def find(self, locator):
        return self.wait.until(EC.presence_of_element_located(locator))

    def click(self, locator):
        el = self.wait.until(EC.element_to_be_clickable(locator))
        el.click()

    def type(self, locator, value: str):
        el = self.find(locator)
        el.clear()
        el.send_keys(value)

    def get_text(self, locator):
        try:
            el = self.wait.until(EC.visibility_of_element_located(locator))
            return el.text.strip()
        except TimeoutException:
            return ""

    def is_visible(self, locator) -> bool:
        try:
            self.wait.until(EC.visibility_of_element_located(locator))
            return True
        except TimeoutException:
            return False

    def screenshot(self, path: str):
        try:
            self.driver.save_screenshot(path)
        except Exception:
            pass
