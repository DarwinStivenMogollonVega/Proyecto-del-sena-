import pytest
from pages.login_page import LoginPage


def test_login_valid(driver, base_url, user_data):
    page = LoginPage(driver, base_url)
    page.open_login()
    # expecting user already exists; if not, use registration flow in tests
    page.login(user_data["email"], user_data["password"])
    assert page.is_visible(("css selector", "#dashboard")) or "dashboard" in driver.current_url


@pytest.mark.parametrize("email,password", [("noexist@example.com", "badpass"), ("", "")])
def test_login_invalid(driver, base_url, email, password):
    page = LoginPage(driver, base_url)
    page.open_login()
    page.login(email, password)
    err = page.get_error()
    assert err and len(err) > 0


def test_logout_flow(driver, base_url, user_data):
    page = LoginPage(driver, base_url)
    page.open_login()
    page.login(user_data["email"], user_data["password"])
    # assume there's a logout link
    driver.find_element_by_css_selector("a.logout").click()
    assert "login" in driver.current_url
