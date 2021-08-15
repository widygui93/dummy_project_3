<?php
class Profile_teacher extends Controller
{
    public function viewProfile(string $username = "")
    {
        if (!$this->model('Verify_model')->isUserLogin()) {

            header('Location: ' . BASEURL . '/Login/teacher');
            exit;
        }

        if (!$this->model('Verify_model')->isLoginAsTeacher()) return $this->model('Verify_model')->goHome();
        if ($_SESSION["username_teacher"] != stripslashes(htmlspecialchars($username))) return $this->model('Verify_model')->goHome();

        $data['profile-teacher'] = $this->model('Profile_teacher_model')->getProfileInfoBy($_SESSION["username_teacher"]);
        if (empty($data['profile-teacher'])) return $this->model('Verify_model')->goHome();


        $data['style'] = BASEURL . '/css/profile-teacher-style.css';
        $twig = $this->view();
        echo $twig->render(
            '/templates/header.html.twig',
            [
                'style' => $data['style'],
                'BASEURL' => BASEURL,
                'login_teacher' => $_SESSION['login_teacher'] ?? false,
                'login_student' => $_SESSION['login_student'] ?? false,
                'username_teacher' => $_SESSION['username_teacher'] ?? '',
                'username_student' => $_SESSION['username_student'] ?? ''
            ]
        );

        echo $twig->render(
            '/profile-teacher/index.html.twig',
            [
                'profile_teacher' => $data['profile-teacher'],
                'BASEURL' => BASEURL

            ]
        );

        echo $twig->render('/templates/footer.html.twig', ['BASEURL' => BASEURL]);
    }
}
