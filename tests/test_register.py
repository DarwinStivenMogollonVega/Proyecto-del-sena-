import pytest
from pages.register_page import RegisterPage


@pytest.mark.parametrize("invalid", [
    {"email": "bademail", "password": "p", "first_name": ""},
    {"email": "", "password": ""},
])
def test_register_invalid(driver, base_url, invalid):
    page = RegisterPage(driver, base_url)
    page.open_register()
    page.register(invalid)
    # Expect validations: presence of error messages
    assert not page.is_visible(page.SUCCESS)


def test_register_and_activate(driver, base_url, user_data):
    page = RegisterPage(driver, base_url)
    page.open_register()
    page.register(user_data)
    # Depending on app flow, there may be success message
    assert page.is_visible(page.SUCCESS) or "verify" in driver.current_url
