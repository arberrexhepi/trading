export async function fetchPreferences() {
    const response = await fetch('../api/preferences.php');
    const data = await response.json();
    if (data.success) {
        document.getElementById('preferred-symbol').textContent = data.preferences.preferred_symbol;
        document.getElementById('risk-level').textContent = data.preferences.risk_level;
    } else {
        console.error('Failed to fetch preferences');
    }
}

export async function updatePreferences(event) {
    event.preventDefault();
    const symbol = document.getElementById('symbol-input').value;
    const riskLevel = document.getElementById('risk-input').value;

    const response = await fetch('../api/preferences.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ symbol, risk_level: riskLevel })
    });
    const data = await response.json();
    if (data.success) {
        alert('Preferences updated successfully!');
        fetchPreferences();
    } else {
        console.error('Failed to update preferences');
    }
}
