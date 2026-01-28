<?php 
session_start();
if(isset($_SESSION['username'])){
    $current_page = 'funduser';
    $user = $_SESSION['username'];
?>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loyola eCard | Make Payment</title>
    <link rel="stylesheet" href="./styles/common.css" />
    <link rel="stylesheet" href="./styles/funduser.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include './components/nav.php'; ?>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="top-header">
                <div class="user-welcome">
                    <i class="fa-solid fa-user"></i>
                    <span>Welcome, <?php echo htmlspecialchars($user); ?></span>
                </div>
            </div>

            <div class="payment-container">
                <h2 class="payment-title">
                    <i class="fa-solid fa-credit-card"></i>
                    Process Payment
                </h2>
                
                <form class="payment-form" action="./backend/process_frontend_transaction.php" method="POST">
                    <!-- Amount Input -->
                    <div class="form-group">
                        <label for="amount">
                            <i class="fa-solid fa-money-bill"></i>
                            Amount
                        </label>
                        <div class="input-wrapper">
                            <span class="currency-symbol">₹</span>
                            <input 
                                type="number" 
                                id="amount" 
                                name="amount" 
                                placeholder="Enter amount" 
                                required
                                min="0"
                                step="0.01"
                            />
                        </div>
                    </div>

                    <!-- Add Toggle Switch -->
                    <div class="form-group">
                        <label class="toggle-switch">
                            <input type="checkbox" id="feeToggle">
                            <span class="slider round"></span>
                            <span class="toggle-label">Include₹3 Fee</span>
                        </label>
                    </div>

                    <!-- Transaction Type Selection -->
                    <div class="form-group">
                        <label for="transaction-type">
                            <i class="fa-solid fa-exchange-alt"></i>
                            Transaction Type
                        </label>
                        <select id="transaction-type" name="transaction_type" required>
                            <option value="credit">Credit (Add Funds)</option>
                            <option value="debit">Debit (Remove Funds)</option>
                        </select>
                    </div>

                    <button type="submit" class="process-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                        Process Payment
                    </button>
                </form>
            </div>
        </main>
    </div>


<script>
 document.getElementById('feeToggle').addEventListener('change', function() {
    const amountInput = document.getElementById('amount');
    const transactionType = document.getElementById('transaction-type');
    
    if (this.checked) {
        amountInput.value = '3.00';
        transactionType.value = 'debit'; 
        amountInput.readOnly = true; 

        submitForm();
    } else {
        amountInput.value = '';
        amountInput.readOnly = false;
    }
});

function submitForm() {
    const amount = document.getElementById('amount').value;
    const feeToggle = document.getElementById('feeToggle').checked;
    const transactionType = document.getElementById('transaction-type').value;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../backend/process_frontend_transaction.php';
    
    const fields = {
        'amount': amount,
        'transaction_type': transactionType,
        'fee_applied': feeToggle ? '1' : '0'
    };
    
    for(const [key, value] of Object.entries(fields)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
}

document.getElementById('amount').addEventListener('input', function() {
    const feeToggle = document.getElementById('feeToggle');
    if (feeToggle.checked) {
        this.value = '3.00';
    }
});
    </script>
    
    <style>
    .toggle-switch {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        background-color: #ccc;
        border-radius: 34px;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .toggle-label {
        margin-left: 10px;
    }
    </style>
</body>
</html>
<?php 
}else{
	header("location: ./index.php");
} 
?>