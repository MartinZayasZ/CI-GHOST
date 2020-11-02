# CI-GHOST
Librería de codeigniter para consultas hacía Ghost CMS

$this->load->library('ghost');
$this->ghost->configure( GHOST_API_URL, GHOST_API_KEY );


$filters = $this->input->get(array('page', 'limit'));
$page = isset( $filters['page'] ) ? $filters['page'] : 0;
$limit = isset( $filters['limit'] ) ? $filters['limit'] : 4;

$posts = $this->ghost->get_all_posts( $page, $limit );
