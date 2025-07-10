<?php
session_start();
include_once __DIR__ . '/../../includes/db.php';

$error = '';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier si l'utilisateur existe
    $stmt = $conn->prepare("SELECT id, email, password, firstname, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Vérifier le mot de passe (supposé hashé dans la base)
    if ($user && password_verify($password, $user['password'])) {
        // Stocker les infos utiles en session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'role' => $user['role'] // adapte selon ta structure
        ];
        // Rediriger vers le dashboard
        header('Location: /dashboard');
        exit;
    } else {
        // Rediriger vers la home avec la modale ouverte et un message d’erreur
        header('Location: /?login=1&error=Identifiants+incorrects');
        exit;
    }
}

// Si on arrive ici sans POST, on redirige vers la home
header('Location: /');
exit;
