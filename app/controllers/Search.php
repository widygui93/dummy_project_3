<?php
class Search extends Controller
{
	public function index()
	{
		$data['style'] = BASEURL . '/css/search-style.css';
		// $data['style'] = BASEURL . '/css/style.css';
		$data['style-tutorial'] = BASEURL . '/css/tutorial-style.css';
		$data['script-modal-detail-tutorial'] = BASEURL . '/js/script-modal-detail-tutorial.js';
		$data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
		$data['script-load-more'] = BASEURL . '/js/script-load-more.js';
		$data['tutorials'] = $this->model('Search_model')->SearchTutorialsBy(strtolower($_POST['q']));
		$data['total-tutorials'] = $this->model('Search_model')->getTotalOfSearchTutorials(strtolower($_POST['q']));
		$cc = 12;


		$twig = $this->view();

		echo $twig->render(
			'/templates/header.html.twig',
			[
				'style' => $data['style'],
				'style_tutorial' => $data['style-tutorial'],
				'BASEURL' => BASEURL,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false,
				'username_teacher' => $_SESSION['username_teacher'] ?? '',
				'username_student' => $_SESSION['username_student'] ?? ''
			]
		);

		echo $twig->render('/search/index.html.twig', ['q' => $_POST['q']]);

		echo $twig->render(
			'/tutorial/student-non-dashboard.html.twig',
			[
				'tutorials' => $data['tutorials'],
				'total_tutorials' => $data['total-tutorials'],
				'BASEURL' => BASEURL
			]
		);

		echo $twig->render(
			'/templates/footer.html.twig',
			[
				'script_axios' => $data['script-axios'],
				'script_modal_detail_tutorial' => $data['script-modal-detail-tutorial'],
				'script_load_more' => $data['script-load-more'],
				'BASEURL' => BASEURL
			]
		);
	}
}
