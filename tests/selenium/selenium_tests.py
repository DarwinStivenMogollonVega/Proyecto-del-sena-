#!/usr/bin/env python3
"""
Pruebas Selenium genéricas (unittest) - Plantilla adaptable

Uso:
  - Configura las variables de entorno antes de ejecutar, por ejemplo:
      set APP_URL=http://localhost:8000
      set TEST_TYPE=login
      set USER_SELECTOR_TYPE=id
      set USER_SELECTOR=username
      set PASS_SELECTOR_TYPE=id
      set PASS_SELECTOR=password
      set BUTTON_SELECTOR_TYPE=id
      set BUTTON_SELECTOR=loginBtn
      set USERNAME=testuser
      set PASSWORD=secret
      set EXPECTED_URL=/dashboard

  - Ejecutar:
      python tests\selenium\selenium_tests.py

Notas:
  - Soporta selector types: id, name, css, xpath
  - Usa WebDriverWait (no sleep)
  - Toma captura en caso de fallo en `tests/selenium/failures/`
"""

import os
import sys
import unittest
import pathlib
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, WebDriverException, ElementClickInterceptedException


def get_by(selector_type: str):
    """Mapea una cadena a la constante By correspondiente."""
    selector_type = (selector_type or '').lower()
    return {
        'id': By.ID,
        'name': By.NAME,
        'css': By.CSS_SELECTOR,
        'xpath': By.XPATH,
    }.get(selector_type, By.CSS_SELECTOR)


class BaseSeleniumTest(unittest.TestCase):
    """Clase base que inicializa WebDriver y provee utilidades."""

    @classmethod
    def setUpClass(cls):
        # Configuración del driver (Chrome por defecto). Habilita headless con HEADLESS=1
        chrome_opts = Options()
        if os.getenv('HEADLESS', '0') == '1':
            chrome_opts.add_argument('--headless=new')
        chrome_opts.add_argument('--no-sandbox')
        chrome_opts.add_argument('--disable-dev-shm-usage')

        # Si chromedriver no está en PATH, ponga su ruta en CHROMEDRIVER_PATH
        chromedriver_path = os.getenv('CHROMEDRIVER_PATH') or None
        try:
            if chromedriver_path:
                cls.driver = webdriver.Chrome(executable_path=chromedriver_path, options=chrome_opts)
            else:
                cls.driver = webdriver.Chrome(options=chrome_opts)
        except TypeError:
            # Compatibilidad con versiones antiguas/newer de selenium
            cls.driver = webdriver.Chrome(options=chrome_opts)

        cls.driver.maximize_window()
        cls.wait = WebDriverWait(cls.driver, int(os.getenv('WAIT_TIMEOUT', '10')))

    @classmethod
    def tearDownClass(cls):
        try:
            cls.driver.quit()
        except Exception:
            pass

    def screenshot_on_failure(self, name: str):
        out_dir = pathlib.Path(__file__).resolve().parent / 'failures'
        out_dir.mkdir(parents=True, exist_ok=True)
        path = out_dir / f"{name}.png"
        try:
            self.driver.save_screenshot(str(path))
        except Exception:
            pass


class LoginTest(BaseSeleniumTest):
    """Test de login genérico que usa variables de entorno para ser parametrizable."""

    def test_login(self):
        """Realiza un login y valida la redirección o texto esperado.

        Variables relevantes (entorno):
          - APP_URL: base URL (obligatorio)
          - USER_SELECTOR_TYPE, USER_SELECTOR
          - PASS_SELECTOR_TYPE, PASS_SELECTOR
          - BUTTON_SELECTOR_TYPE, BUTTON_SELECTOR
          - USERNAME, PASSWORD
          - EXPECTED_URL (subruta) o EXPECTED_TEXT (texto visible)
        """
        base = os.getenv('APP_URL')
        if not base:
            self.skipTest('APP_URL no está definida')

        # Selectors y credenciales
        user_sel_type = os.getenv('USER_SELECTOR_TYPE', 'id')
        user_sel = os.getenv('USER_SELECTOR')
        pass_sel_type = os.getenv('PASS_SELECTOR_TYPE', 'id')
        pass_sel = os.getenv('PASS_SELECTOR')
        btn_sel_type = os.getenv('BUTTON_SELECTOR_TYPE', 'id')
        btn_sel = os.getenv('BUTTON_SELECTOR')

        username = os.getenv('USERNAME', '')
        password = os.getenv('PASSWORD', '')

        expected_url = os.getenv('EXPECTED_URL')
        expected_text = os.getenv('EXPECTED_TEXT')

        # Navegar a la página de login
        try:
            self.driver.get(base)
        except WebDriverException as e:
            self.fail(f'No se pudo abrir {base}: {e}')

        # Localizar campos usando WebDriverWait y luego interactuar
        try:
            user_by = get_by(user_sel_type)
            pass_by = get_by(pass_sel_type)
            btn_by = get_by(btn_sel_type)

            self.wait.until(EC.presence_of_element_located((user_by, user_sel)))
            elem_user = self.driver.find_element(user_by, user_sel)
            elem_user.clear()
            elem_user.send_keys(username)

            self.wait.until(EC.presence_of_element_located((pass_by, pass_sel)))
            elem_pass = self.driver.find_element(pass_by, pass_sel)
            elem_pass.clear()
            elem_pass.send_keys(password)

            # Clic en el botón (con fallback a JS click / submit si hay intercepción)
            self.wait.until(EC.presence_of_element_located((btn_by, btn_sel)))
            btn = self.driver.find_element(btn_by, btn_sel)
            try:
                self.wait.until(EC.element_to_be_clickable((btn_by, btn_sel)))
                btn.click()
            except ElementClickInterceptedException:
                # Intentar clic por JS
                try:
                    self.driver.execute_script("arguments[0].click();", btn)
                except Exception:
                    # último recurso: buscar el formulario y hacer submit
                    try:
                        form = btn.find_element(By.XPATH, 'ancestor::form')
                        form.submit()
                    except Exception:
                        raise

            # Validaciones: preferir EXPECTED_URL si está definido
            if expected_url:
                # Esperar que la URL contenga la subruta esperada
                self.wait.until(EC.url_contains(expected_url))
                current = self.driver.current_url
                self.assertIn(expected_url, current, f'La URL actual {current} no contiene {expected_url}')
            elif expected_text:
                # Esperar presencia del texto en el body
                self.wait.until(EC.text_to_be_present_in_element((By.TAG_NAME, 'body'), expected_text))
                body = self.driver.find_element(By.TAG_NAME, 'body').text
                self.assertIn(expected_text, body, f'No se encontró el texto esperado: {expected_text}')
            else:
                # Si no hay expectativa definida, al menos validar que la página cambió
                self.wait.until(lambda d: d.current_url != base)
                self.assertNotEqual(self.driver.current_url, base)

        except TimeoutException as te:
            # Capturar estado y fallar con detalle
            self.screenshot_on_failure('login_timeout')
            self.fail(f'Elemento no encontrado o timeout: {te}')
        except AssertionError:
            self.screenshot_on_failure('login_assert')
            raise
        except Exception as e:
            self.screenshot_on_failure('login_error')
            self.fail(f'Error inesperado en test_login: {e}')


class FormTest(BaseSeleniumTest):
    """Test para formularios genérico.

    Variables (ejemplo):
      - APP_URL
      - FORM_SELECTORS: un listado simple separado por | de pares tipo:selector,ej: name:email|id:submitBtn
      - EXPECTED_TEXT
    """

    def test_form_submission(self):
        base = os.getenv('APP_URL')
        if not base:
            self.skipTest('APP_URL no está definida')

        form_selectors = os.getenv('FORM_SELECTORS')
        expected_text = os.getenv('EXPECTED_TEXT')

        try:
            self.driver.get(base)
            if form_selectors:
                pairs = [p for p in form_selectors.split('|') if p.strip()]
                for pair in pairs:
                    # Formato: type:selector=value  (ej name:email=foo@x.com) o type:selector (solo click)
                    if '=' in pair:
                        left, value = pair.split('=', 1)
                    else:
                        left, value = pair, None
                    sel_type, sel = left.split(':', 1)
                    by = get_by(sel_type)
                    self.wait.until(EC.presence_of_element_located((by, sel)))
                    el = self.driver.find_element(by, sel)
                    if value is not None:
                        el.clear()
                        el.send_keys(value)
                    else:
                        # Asumir botón
                        el.click()

            if expected_text:
                self.wait.until(EC.text_to_be_present_in_element((By.TAG_NAME, 'body'), expected_text))
                self.assertIn(expected_text, self.driver.find_element(By.TAG_NAME, 'body').text)

        except TimeoutException as te:
            self.screenshot_on_failure('form_timeout')
            self.fail(f'Elemento no encontrado o timeout en form: {te}')
        except Exception as e:
            self.screenshot_on_failure('form_error')
            self.fail(f'Error inesperado en test_form_submission: {e}')


if __name__ == '__main__':
    # Para ejecutar un test concreto use TEST_TYPE=login o TEST_TYPE=form
    test_type = os.getenv('TEST_TYPE', 'login').lower()
    if test_type == 'login':
        suite = unittest.TestLoader().loadTestsFromTestCase(LoginTest)
    elif test_type == 'form':
        suite = unittest.TestLoader().loadTestsFromTestCase(FormTest)
    else:
        print('TEST_TYPE no reconocido, opciones: login, form')
        sys.exit(2)

    runner = unittest.TextTestRunner(verbosity=2)
    result = runner.run(suite)
    sys.exit(0 if result.wasSuccessful() else 1)
