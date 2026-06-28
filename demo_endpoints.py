import urllib.request
import urllib.parse

def post(url, params):
    data = urllib.parse.urlencode(params).encode('utf-8')
    req = urllib.request.Request(url, data=data, headers={'Content-Type': 'application/x-www-form-urlencoded'})
    with urllib.request.urlopen(req, timeout=10) as resp:
        return resp.status, resp.read().decode('utf-8')

urls = [
    ('http://localhost/WeddingSampleSystem/register.php', {'email': 'testuser@example.com', 'fullname': 'Test User', 'password': 'Password123', 'confirm_password': 'Password123'}),
    ('http://localhost/WeddingSampleSystem/login.php', {'email': 'testuser@example.com', 'password': 'Password123'})
]

for url, params in urls:
    try:
        status, body = post(url, params)
        print('URL:', url)
        print('STATUS:', status)
        print(body)
    except Exception as e:
        print('URL:', url)
        print('ERROR:', repr(e))
