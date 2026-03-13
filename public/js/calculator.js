const calculator = document.querySelector(".calculator");
const display = document.getElementById("display");
const historyEl = document.getElementById("history");
const buttons = document.querySelectorAll(".calc-btn");

if (!calculator || !display || !historyEl || buttons.length === 0) {
  console.warn("Calculator elements not found.");
} else {
  let currentInput = "0";
  let expression = "";
  let shouldResetInput = false;

  function animateDisplay() {
    display.classList.remove("calc-pop");
    void display.offsetWidth;
    display.classList.add("calc-pop");
  }

  function animateError() {
    calculator.classList.remove("calc-shake");
    void calculator.offsetWidth;
    calculator.classList.add("calc-shake");
  }

  function animateButton(button) {
    button.classList.remove("calc-press");
    void button.offsetWidth;
    button.classList.add("calc-press");
  }

  function updateDisplay(value = currentInput) {
    display.textContent = formatNumber(value);
    animateDisplay();
  }

  function updateHistory(value = expression || "0") {
    historyEl.textContent = value;
  }

  function formatNumber(value) {
    if (value === "" || value === null || value === undefined) return "0";
    if (value === "Error") return "Error";

    const str = value.toString();

    if (/[+\-*/%]/.test(str) && isNaN(str)) return str;

    const parts = str.split(".");
    const integerPart = parts[0];
    const decimalPart = parts[1];

    const formattedInteger = isNaN(integerPart)
      ? integerPart
      : Number(integerPart).toLocaleString("en-US");

    return decimalPart !== undefined
      ? `${formattedInteger}.${decimalPart}`
      : formattedInteger;
  }

  function sanitizeExpression(expr) {
    return expr
      .replace(/×/g, "*")
      .replace(/÷/g, "/")
      .replace(/−/g, "-");
  }

  function clearAll() {
    currentInput = "0";
    expression = "";
    shouldResetInput = false;
    updateHistory("0");
    updateDisplay("0");
  }

  function deleteLast() {
    if (currentInput === "Error") {
      clearAll();
      return;
    }

    if (shouldResetInput) return;

    currentInput = currentInput.length > 1
      ? currentInput.slice(0, -1)
      : "0";

    updateDisplay();
  }

  function handleNumber(value) {
    if (currentInput === "Error") {
      currentInput = value;
      updateDisplay();
      return;
    }

    if (shouldResetInput) {
      currentInput = value;
      shouldResetInput = false;
    } else {
      currentInput = currentInput === "0" ? value : currentInput + value;
    }

    updateDisplay();
  }

  function handleDecimal() {
    if (currentInput === "Error") {
      currentInput = "0.";
      updateDisplay();
      return;
    }

    if (shouldResetInput) {
      currentInput = "0.";
      shouldResetInput = false;
      updateDisplay();
      return;
    }

    if (!currentInput.includes(".")) {
      currentInput += ".";
      updateDisplay();
    }
  }

  function handleOperator(operator) {
    if (currentInput === "Error") return;

    if (expression && !shouldResetInput) {
      calculateResult();
      if (currentInput === "Error") return;
    }

    expression = `${currentInput}${operator}`;
    updateHistory(expression);
    shouldResetInput = true;
  }

  function calculateResult() {
    try {
      const safeExpression = sanitizeExpression(expression + currentInput);

      if (!/^[0-9+\-*/%.() ]+$/.test(safeExpression)) {
        throw new Error("Invalid expression");
      }

      const result = Function(`"use strict"; return (${safeExpression})`)();

      if (!isFinite(result)) {
        throw new Error("Math error");
      }

      historyEl.textContent = `${expression}${currentInput} =`;
      currentInput = Number.isInteger(result)
        ? String(result)
        : String(+result.toFixed(8));

      expression = "";
      shouldResetInput = true;
      updateDisplay();
    } catch (error) {
      currentInput = "Error";
      updateDisplay("Error");
      animateError();
    }
  }

  buttons.forEach((button) => {
    button.addEventListener("click", () => {
      animateButton(button);

      const value = button.dataset.value;
      const action = button.dataset.action;

      if (action === "clear") return clearAll();
      if (action === "delete") return deleteLast();
      if (action === "calculate") return calculateResult();

      if (!isNaN(value)) return handleNumber(value);
      if (value === ".") return handleDecimal();
      if (["+", "-", "*", "/", "%"].includes(value)) return handleOperator(value);
    });
  });

  window.addEventListener("keydown", (e) => {
    const key = e.key;

    if (!isNaN(key)) handleNumber(key);
    else if (key === ".") handleDecimal();
    else if (["+", "-", "*", "/", "%"].includes(key)) handleOperator(key);
    else if (key === "Enter" || key === "=") {
      e.preventDefault();
      calculateResult();
    } else if (key === "Backspace") {
      deleteLast();
    } else if (key === "Escape") {
      clearAll();
    }
  });

  updateDisplay("0");
  updateHistory("0");
}
