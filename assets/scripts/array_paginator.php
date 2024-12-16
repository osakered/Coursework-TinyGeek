<?php
class ArrayPaginator
{
    public $page = 1;  
    public $limit = 10; 
    public $total = 0;
    public $amt = 0; 
    public $display = '';  

    private $data = [];     
    private $url = '';     
    private $carrier = 'page';

    public function __construct($url, $limit = 10)
    {
        $this->url = $url;
        $this->limit = $limit;

        $page = intval(@$_GET['page']);
        if ($page > 0) {
            $this->page = $page;
        }

        $queryParams = $_GET;
        unset($queryParams['page']); 
        $this->queryString = http_build_query($queryParams);

        $query = parse_url($this->url, PHP_URL_QUERY);
        $this->carrier = empty($query) ? '?' . $this->carrier . '=' : '&' . $this->carrier . '=';
    }

    public function setItems(array $array)
    {
        $this->data = $array;
        $this->total = count($this->data);
        $this->amt = ceil($this->total / $this->limit);
        $this->page = min($this->page, $this->amt); 
    }

    public function getItems()
    {
        $start = ($this->page - 1) * $this->limit;
        return array_slice($this->data, $start, $this->limit);
    }

    public function deleteItems()
    {
        echo "
        <script> 
        function removeElement(selector) {
        const element = document.querySelector(selector);
        if (element) {
            element.remove();
        } else {
            console.log('Элемент не найден');
        }   
    }
    
    removeElement('#pagination'); 
    
            </script>
        ";
    }

    public function redirectToFirstPage()
    {
        if ($this->page > 1) {
            header("Location: " . $this->url . $this->carrier . "1");
            exit();
        }
    }

    public function renderPagination()
    {
        if ($this->amt <= 1) {
            return '';
        }

        $this->display = '<nav class="pagination" id="pagination"><ul class="pagination">';

        if ($this->page > 1) {
            $this->addLink('«', $this->carrier . ($this->page - 1), 'prev');
        } else {
            $this->addSpan('«', 'disabled');
        }

        for ($i = 1; $i <= $this->amt; $i++) {
            if ($i == $this->page) {
                $this->addSpan($i, 'active');
            } else {
                $this->addLink($i, $this->carrier . $i);
            }
        }

        if ($this->page < $this->amt) {
            $this->addLink('»', $this->carrier . ($this->page + 1), 'next');
        } else {
            $this->addSpan('»', 'disabled');
        }

        $this->display .= '</ul></nav>';
        return $this->display;
    }

    private function addSpan($text, $class = '')
    {
        $this->display .= '<li class="page-item ' . $class . '"><span class="page-link">' . $text . '</span></li>';
    }

    private function addLink($text, $url, $class = '')
    {
        $this->display .= '<li class="page-item ' . $class . '"><a class="page-link" href="' . $this->url . $url . '&' . $this->queryString . '">' . $text . '</a></li>';
    }
}
?>