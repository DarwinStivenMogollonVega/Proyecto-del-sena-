import pytest
from pages.item_page import ItemPage
from utils.data_generator import fake_user


def test_crud_create_list_delete(driver, base_url):
    page = ItemPage(driver, base_url)
    page.open_list()
    before = page.list_count()
    name = "test-item-" + fake_user()["first_name"]
    page.create_item(name)
    assert page.is_visible(page.SUCCESS)
    after = page.list_count()
    assert after == before + 1
    page.delete_first()
    assert page.is_visible(page.SUCCESS)
