import './bootstrap';

// Health Bar Update
function updateHealthBar() {
    let vidaInput = document.getElementById('vida');
    let healthBarInner = document.getElementById('health-bar-inner');
    let vida = vidaInput.value;
    let percentage = (vida / 100) * 100;
    
    healthBarInner.style.width = percentage + '%';
    
    if (percentage > 50) {
        healthBarInner.style.backgroundColor = 'green';
    } else if (percentage > 25) {
        healthBarInner.style.backgroundColor = 'yellow';
    } else {
        healthBarInner.style.backgroundColor = 'red';
    }
}


function calculateModifier(value) {
    value = parseInt(value) || 0;
    if (value === 0) return -2;
    if (value === 1) return -1;
    if (value >= 2 && value <= 3) return 0;
    if (value >= 4 && value <= 5) return +1;
    if (value >= 6) return +2;
    return 0;
}

function updateModifierSquares() {
    document.querySelectorAll('.attribute-input').forEach(input => {
        const modifierValue = calculateModifier(input.value);
        const modifierSquare = document.querySelector(`[data-for="${input.name}"]`);
        if (modifierSquare) {
            modifierSquare.textContent = modifierValue >= 0 ? `+${modifierValue}` : modifierValue;
            
            // Update background colors
            modifierSquare.style.backgroundColor = 
                modifierValue === -2 ? '#ff9999' :
                modifierValue === -1 ? '#ffcc99' :
                modifierValue === 0 ? '#e9ecef' :
                modifierValue === +1 ? '#b3ffb3' :
                '#99ccff';
        }
    });
}

// Event Listeners
document.querySelectorAll('.attribute-input').forEach(input => {
    input.addEventListener('input', updateModifierSquares);
});

// Initial Calculation
updateModifierSquares();

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
    }
}