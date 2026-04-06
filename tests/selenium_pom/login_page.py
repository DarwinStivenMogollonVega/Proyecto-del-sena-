from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
from typing import Optional

# Replace this with your base URL before running tests
BASE_URL = "COLOCA_AQUI_LA_URL"


class LoginPage:
    """Page Object Model for the login page.

    Replace the selector constants below with the real selectors from your app.
    """

    # Selectors (update these to match your DOM)
    USERNAME = (By.ID, "username")         # e.g. (By.NAME, 'email')
    PASSWORD = (By.ID, "password")         # e.g. (By.NAME, 'password')
    SUBMIT = (By.XPATH, "//button[@type='submit']")
    ERROR_MSG = (By.CSS_SELECTOR, ".alert-danger")
    DASHBOARD_INDICATOR = (By.CSS_SELECTOR, "#dashboard")  # element that proves successful login

    def __init__(self, driver, base_url: Optional[str] = None, timeout: int = 10):
        self.driver = driver
        self.base_url = base_url or BASE_URL
        self.wait = WebDriverWait(driver, timeout)

    def open(self, path: str = "/"):
        """Open login page (or a path relative to base_url)."""
        url = self.base_url.rstrip("/") + path
        self.driver.get(url)

    def set_username(self, username: str):
        el = self.wait.until(EC.presence_of_element_located(self.USERNAME))
        el.clear()
        el.send_keys(username)

    def set_password(self, password: str):
        el = self.wait.until(EC.presence_of_element_located(self.PASSWORD))
        el.clear()
        el.send_keys(password)

    def submit(self):
        btn = self.wait.until(EC.element_to_be_clickable(self.SUBMIT))
        btn.click()

    def login(self, username: str, password: str):
        """Convenience method that fills the form and submits it."""
        try:
            self.set_username(username)
            self.set_password(password)
            self.submit()
        except (TimeoutException, NoSuchElementException) as e:
            raise RuntimeError(f"Error interacting with login form: {e}")

    def get_error_message(self) -> Optional[str]:
        """Return visible error message text, or None if not found."""
        try:
            el = self.wait.until(EC.visibility_of_element_located(self.ERROR_MSG))
            return el.text.strip()
        except TimeoutException:
            return None

    def is_logged_in(self) -> bool:
        """Detect successful login by presence of a dashboard indicator element or URL change."""
        try:
            self.wait.until(EC.presence_of_element_located(self.DASHBOARD_INDICATOR))
            return True
        except TimeoutException:
            # as fallback, check URL contains 'dashboard'
            try:
                return "dashboard" in self.driver.current_url
            except Exception:
                return False
