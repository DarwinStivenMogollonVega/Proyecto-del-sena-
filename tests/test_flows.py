import pytest
from pages.login_page import LoginPage
from pages.item_page import ItemPage


def test_end_to_end_purchase_flow(driver, base_url, user_data):
    # Example skeleton for a purchase flow: add to cart -> checkout
    login = LoginPage(driver, base_url)
    login.open_login()
    login.login(user_data["email"], user_data["password"])
    assert login.is_visible(("css selector", "#dashboard")) or "dashboard" in driver.current_url

    items = ItemPage(driver, base_url)
    items.open_list()
    # this is highly app-specific: just show placeholders
    items.click(("css selector", "button.add-to-cart"))
    items.click(("css selector", "a.checkout"))
    assert "order" in driver.current_url or items.is_visible(("css selector", ".order-confirmation"))
