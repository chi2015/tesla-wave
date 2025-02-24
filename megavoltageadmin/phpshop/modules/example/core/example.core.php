<?
// Example - �������� ������
class PHPShopExample extends PHPShopCore {

    // �����������
    function PHPShopExample() {
        $this->objBase=$GLOBALS['SysValue']['base']['example']['example_system'];
        $this->debug=false;
        parent::PHPShopCore();

        // ���������� �� �������
        if($this->PHPShopNav->objNav['query']['info']) exit(phpinfo());
    }


    function index() {

        // ������� ������
        $row=$this->PHPShopOrm->select();

        // ���������� ���������
        $this->set('pageContent',Parser($row['example']));
        $this->set('pageTitle','Example');

        // ��������� ���������� ����������
        $info='<p>���������� ������������ ������ phpshop/modules/example/core/example.core.php<br>
            ��� ��������� ���������� �� ������� PhpInfo() ������� �� <a href="?info=true">������</a>.
            <p>
            <h4>�������� API PHPShopCore</h4>
            <iframe src="http://doc.phpshopcms.ru/PHPShopClass/PHPShopCore.html" width="100%" height="500" frameborder="0"></iframe>
            <p><a href="http://doc.phpshopcms.ru/PHPShopClass/PHPShopCore.html" target="_blank">������� � ��������� ����</a>';
        $this->set('pageContent',$info,true);

        // ����
        $this->title="Example - ".$this->PHPShopSystem->getValue("name");

        // ��������� ������� ������
        $this->navigation(false,'Example');

        // ���������� ������
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

}

?>