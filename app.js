// Sélection des éléments du DOM (le formulaire + le tbody du tableau)
const form = document.getElementById('candle-form');
const tableBody = document.querySelector('#inventory-table tbody');

// Récupération des bougies depuis le localStorage (ou tableau vide au premier chargement)
let candles = JSON.parse(localStorage.getItem('candles')) || [];

// Sauvegarde du tableau de bougies dans le localStorage
function saveData() {
  localStorage.setItem('candles', JSON.stringify(candles));
}

// Affichage des bougies dans le tableau HTML
function renderTable() {
  tableBody.innerHTML = '';

  candles.forEach((candle, index) => {
    const row = document.createElement('tr');

    row.innerHTML = `
      <td>${candle.name}</td>
      <td>${candle.scent}</td>
      <td>${candle.quantity}</td>
      <td>${candle.available}</td>
      <td>${candle.color}</td>
      <td>${candle.shape}</td>
      <td>${candle.price}</td>
      <td>${candle.sale}</td>
      <td>
        <button class="edit" onclick="editCandle(${index})">Modifier</button>
        <button class="delete" onclick="deleteCandle(${index})">Supprimer</button>
      </td>
    `;

    tableBody.appendChild(row);
  });
}

// Ajout ou modification d’une bougie via le formulaire
form.addEventListener('submit', (e) => {
  e.preventDefault();

  const candle = {
    name: form.name.value,
    scent: form.scent.value,
    quantity: form.quantity.value,
    available: form.available.value,
    color: form.color.value,
    shape: form.shape.value,
    price: form.price.value,
    sale: form.sale.value,
  };

  // Si un index d’édition est présent, je remplace la bougie existante
  if (form.dataset.editIndex) {
    const index = form.dataset.editIndex;
    candles[index] = candle;
    delete form.dataset.editIndex;
  } else {
    // Sinon, j’ajoute une nouvelle bougie
    candles.push(candle);
  }

  saveData();
  renderTable();
  form.reset();
});

// Suppression d’une bougie du tableau et du localStorage
function deleteCandle(index) {
  if (confirm('Supprimer cette bougie ?')) {
    candles.splice(index, 1);
    saveData();
    renderTable();
  }
}

// Pré-remplissage du formulaire pour modifier une bougie existante
function editCandle(index) {
  const candle = candles[index];
  form.name.value = candle.name;
  form.scent.value = candle.scent;
  form.quantity.value = candle.quantity;
  form.available.value = candle.available;
  form.color.value = candle.color;
  form.shape.value = candle.shape;
  form.price.value = candle.price;
  form.sale.value = candle.sale;

  // Je mémorise l’index pour savoir que je suis en mode édition
  form.dataset.editIndex = index;
}

// Affiche les données dès le chargement de la page
renderTable();

// Gestion du bouton "Sauvegarder" pour mettre à jour le stock côté serveur (PHP)
document.querySelectorAll('.save-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    const qteTotal = document.querySelector(`.qte_total[data-id="${id}"]`).value;
    const qteDispo = document.querySelector(`.qte_dispo[data-id="${id}"]`).value;

    // Requête AJAX vers update_stock.php pour mettre à jour la base de données
    fetch('update_stock.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${id}&qte_total=${qteTotal}&qte_dispo=${qteDispo}`
    })
    .then(res => res.text())
    .then(txt => {
      alert(txt); // Retour simple : j’affiche le message renvoyé par le PHP
    })
    .catch(err => alert("Erreur de mise à jour : " + err));
  });
});

// =======================================================
// GESTION DES CHAMPS "NOUVELLE VALEUR" (forme, parfum, couleur)
// Affiche automatiquement un champ texte si l'utilisateur
// choisit l'option "__new" dans un <select>
// =======================================================

function toggleField(selectId, inputId) {
  const sel = document.getElementById(selectId);
  const input = document.getElementById(inputId);
  if (!sel || !input) return; // Sécurité si l’élément n’existe pas

  sel.addEventListener('change', () => {
    if (sel.value === '__new') {
      // L’utilisateur choisit "Ajouter une nouvelle valeur"
      input.classList.remove('hidden');
      input.required = true;
    } else {
      // Retour à une valeur existante
      input.classList.add('hidden');
      input.required = false;
    }
  });
}

// Activation pour chaque liste déroulante
toggleField('forme_id', 'new_forme');
toggleField('parfum_id', 'new_parfum');
toggleField('couleur_id', 'new_couleur');
