import pytest
from pages.profile_page import ProfilePage


def test_profile_edit_validation(driver, base_url, user_data):
    page = ProfilePage(driver, base_url)
    page.open_profile()
    # attempt to update with invalid data
    page.edit_profile("", "")
    # Expect no success message
    assert not page.is_visible(page.SUCCESS)


def test_profile_edit_success(driver, base_url, user_data):
    page = ProfilePage(driver, base_url)
    page.open_profile()
    page.edit_profile(user_data["first_name"], user_data["last_name"])
    assert page.is_visible(page.SUCCESS)
