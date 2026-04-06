from faker import Faker
import os

_fake = Faker()


def fake_user(overrides: dict = None) -> dict:
    overrides = overrides or {}
    user = {
        "email": os.environ.get("TEST_USER", _fake.unique.email()),
        "password": os.environ.get("TEST_PASS", "Password123!"),
        "first_name": _fake.first_name(),
        "last_name": _fake.last_name(),
    }
    user.update(overrides)
    return user
