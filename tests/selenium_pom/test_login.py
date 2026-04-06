import os
import pytest
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

from tests.selenium_pom.login_page import LoginPage, BASE_URL


# --- Test data (replace with real data) ---
VALID_USER = os.environ.get("TEST_USER", "usuario_valido@example.com")
VALID_PASS = os.environ.get("TEST_PASS", "Password123")

INVALID_USER = "no_existe@example.com"
INVALID_PASS = "badpass"


@pytest.fixture(scope="function")
def driver():
    options = Options()
    # run headless by setting HEADLESS=1 env var
    if os.environ.get("HEADLESS", "0") == "1":
        options.add_argument("--headless=new")
    options.add_argument("--no-sandbox")
    options.add_argument("--disable-dev-shm-usage")

    service = Service(ChromeDriverManager().install())
    drv = webdriver.Chrome(service=service, options=options)
    drv.maximize_window()
    yield drv
    drv.quit()


def test_login_success(driver):
    """Validar inicio de sesión exitoso: debe redirigir al dashboard."""
    page = LoginPage(driver, base_url=BASE_URL)
    page.open("/")
    page.login(VALID_USER, VALID_PASS)
    assert page.is_logged_in(), "Usuario no fue redirigido al dashboard tras login exitoso"


def test_login_invalid_credentials(driver):
    """Intento con credenciales inválidas muestra mensaje de error."""
    page = LoginPage(driver, base_url=BASE_URL)
    page.open("/")
    page.login(INVALID_USER, INVALID_PASS)
    err = page.get_error_message()
    assert err is not None and len(err) > 0, "Se esperaba un mensaje de error visible para credenciales inválidas"
