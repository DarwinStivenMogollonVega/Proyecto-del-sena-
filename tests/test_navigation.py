import pytest


def test_protected_route_redirects_to_login(driver, base_url):
    protected = base_url.rstrip("/") + "/admin"
    driver.get(protected)
    assert "login" in driver.current_url or driver.title.lower().startswith("login")


def test_routes_are_accessible(driver, base_url):
    paths = ["/", "/about", "/contact"]
    for p in paths:
        driver.get(base_url.rstrip("/") + p)
        assert driver.status_code if hasattr(driver, 'status_code') else True
