export async function fetchTradeHistory() {
  const response = await fetch("../api/trades.php");
  const data = await response.json();
  if (data.success) {
    const tradeTable = document.getElementById("trade-history");
    tradeTable.innerHTML = "";
    data.trades.forEach((trade) => {
      const newRow = document.createElement("tr");
      newRow.innerHTML = `<td>${trade.symbol}</td>
            <td>${trade.trade_type}</td>
            <td>${trade.quantity}</td>
            <td>${trade.price}</td>
            <td>${trade.executed_at}</td>`;
      tradeTable.appendChild(newRow);
    });
  } else {
    console.error("Failed to fech trade history");
  }
}

export async function logTrade(event) {
  event.preventDefault();
  const symbol = document.getElementById("trade-symbol").value;
  const tradeType = document.getElementById("trade-type").value;
  const quantity = document.getElementById("trade-quantity").value;
  const price = document.getElementById("trade-price").value;

  const response = await fetch("../api/trades.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ symbol, trade_type, quantity, price }),
  });
  const data = await response.json();
  if (data.success) {
    alert("Trade logged successfully!");
    fetchTradeHistory();
  } else {
    console.error("Failed to log trade");
  }
}
