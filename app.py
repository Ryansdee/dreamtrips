import requests
from bs4 import BeautifulSoup

# URL de la page à scraper
url = 'https://www.tui.be/fr/hotel/espagne/costa-blanca/prince-park-00633'

# Obtenir le contenu de la page
response = requests.get(url)
soup = BeautifulSoup(response.content, 'html.parser')

# Exemple de récupération des données
def extract_data():
    # Récupération du titre de l'hôtel
    title = soup.find('h1', class_='some-class-for-title')  # Remplacez 'some-class-for-title' par la classe réelle du titre
    if title:
        title_text = title.get_text(strip=True)
    else:
        title_text = 'Titre non trouvé'

    # Récupération de la description de l'hôtel
    description = soup.find('div', class_='some-class-for-description')  # Remplacez 'some-class-for-description' par la classe réelle
    if description:
        description_text = description.get_text(strip=True)
    else:
        description_text = 'Description non trouvée'

    # Récupération des images
    images = soup.find_all('img')
    image_urls = [img['src'] for img in images if 'src' in img.attrs]

    return {
        'title': title_text,
        'description': description_text,
        'images': image_urls
    }

# Extraire les données
data = extract_data()

# Afficher les données
print('Title:', data['title'])
print('Description:', data['description'])
print('Images:', data['images'])
