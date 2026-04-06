from selenium.webdriver.common.by import By
from pages.base_page import BasePage


class LoginPage(BasePage):
    # Update selectors to match your DOM
    USERNAME = (By.ID, "email")
    PASSWORD = (By.ID, "password")
    SUBMIT = (By.CSS_SELECTOR, "button[type='submit']")
    ERROR = (By.CSS_SELECTOR, ".alert-danger")

    def open_login(self):
        self.open("/login")

    def login(self, username: str, password: str):
        self.type(self.USERNAME, username)
        self.type(self.PASSWORD, password)
        self.click(self.SUBMIT)

    def get_error(self) -> str:
        return self.get_text(self.ERROR)
