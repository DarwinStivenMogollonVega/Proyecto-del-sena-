import os
import pytest
from utils.config import cfg
from utils.driver_factory import create_driver
from utils.data_generator import fake_user


@pytest.fixture(scope="session")
def base_url():
    return os.environ.get("BASE_URL", cfg.BASE_URL)


@pytest.fixture(scope="function")
def driver(request):
    driver = create_driver()

    yield driver

    # teardown: capture screenshot on failure is handled in hook
    driver.quit()


@pytest.fixture
def user_data():
    return fake_user()


def pytest_addoption(parser):
    parser.addoption("--base-url", action="store", default=cfg.BASE_URL)


@pytest.hookimpl(tryfirst=True, hookwrapper=True)
def pytest_runtest_makereport(item, call):
    # Capture screenshot on test failure
    outcome = yield
    rep = outcome.get_result()
    if rep.when == "call" and rep.failed:
        drv = item.funcargs.get("driver")
        if drv:
            screenshot_dir = os.path.join(os.getcwd(), "tests", "reports")
            os.makedirs(screenshot_dir, exist_ok=True)
            path = os.path.join(screenshot_dir, f"{item.name}.png")
            try:
                drv.save_screenshot(path)
            except Exception:
                pass
