from selenium.webdriver.common.by import By
from pages.base_page import BasePage


class ItemPage(BasePage):
    # generic CRUD page placeholders
    NEW_BUTTON = (By.CSS_SELECTOR, "a.new-item")
    NAME = (By.ID, "name")
    SAVE = (By.CSS_SELECTOR, "button.save")
    LIST_ROWS = (By.CSS_SELECTOR, "table tbody tr")
    EDIT_BTN = (By.CSS_SELECTOR, "button.edit")
    DELETE_BTN = (By.CSS_SELECTOR, "button.delete")
    CONFIRM_DELETE = (By.CSS_SELECTOR, "button.confirm-delete")
    SUCCESS = (By.CSS_SELECTOR, ".alert-success")

    def open_list(self):
        self.open("/items")

    def create_item(self, name: str):
        self.click(self.NEW_BUTTON)
        self.type(self.NAME, name)
        self.click(self.SAVE)

    def list_count(self) -> int:
        els = self.driver.find_elements(*self.LIST_ROWS)
        return len(els)

    def delete_first(self):
        if self.is_visible(self.DELETE_BTN):
            self.click(self.DELETE_BTN)
            self.click(self.CONFIRM_DELETE)

    def success_message(self) -> str:
        return self.get_text(self.SUCCESS)
