from selenium.webdriver.common.by import By
from pages.base_page import BasePage


class ProfilePage(BasePage):
    EDIT_BUTTON = (By.CSS_SELECTOR, "a.edit-profile")
    FIRST_NAME = (By.ID, "first_name")
    LAST_NAME = (By.ID, "last_name")
    SAVE = (By.CSS_SELECTOR, "button.save")
    SUCCESS = (By.CSS_SELECTOR, ".alert-success")

    def open_profile(self):
        self.open("/profile")

    def edit_profile(self, first_name: str, last_name: str):
        if self.is_visible(self.EDIT_BUTTON):
            self.click(self.EDIT_BUTTON)
        self.type(self.FIRST_NAME, first_name)
        self.type(self.LAST_NAME, last_name)
        self.click(self.SAVE)

    def success_message(self) -> str:
        return self.get_text(self.SUCCESS)
