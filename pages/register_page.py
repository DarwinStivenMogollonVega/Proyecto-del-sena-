from selenium.webdriver.common.by import By
from pages.base_page import BasePage


class RegisterPage(BasePage):
    EMAIL = (By.ID, "email")
    PASSWORD = (By.ID, "password")
    PASSWORD_CONFIRM = (By.ID, "password_confirmation")
    FIRST_NAME = (By.ID, "first_name")
    LAST_NAME = (By.ID, "last_name")
    SUBMIT = (By.CSS_SELECTOR, "button[type='submit']")
    SUCCESS = (By.CSS_SELECTOR, ".alert-success")

    def open_register(self):
        self.open("/register")

    def register(self, user: dict):
        self.type(self.EMAIL, user["email"])
        self.type(self.FIRST_NAME, user.get("first_name", ""))
        self.type(self.LAST_NAME, user.get("last_name", ""))
        self.type(self.PASSWORD, user["password"])
        self.type(self.PASSWORD_CONFIRM, user["password"])
        self.click(self.SUBMIT)

    def success_message(self) -> str:
        return self.get_text(self.SUCCESS)
