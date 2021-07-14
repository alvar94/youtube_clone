<?php
class VideoDetailsFormProvider {

    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function createUploadForm() {
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput();
        $descriptionInput = $this->createDescriptionInput();
        $privacyInput = $this->createPrivacyInput();
        $categoriesInput = $this->createCategoriesInput();
        $uploadButton = $this->createUploadButton();
        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $privacyInput
                    $categoriesInput
                    $uploadButton 
                </form>";
    }

    private function createFileInput() {

        return "<div class='mb-3'>
                    <label for='formFile' class='form-label'>Your file</label>
                    <input class='form-control' type='file' id='formFile' name='fileInput' required>
                </div>";
    }

    private function createTitleInput() {
        return "<div class='mb-3'>
                    <input class='form-control' type='text' placeholder='Title' name='titleInput'>
                </div>";
    }

    private function createDescriptionInput() {
        return "<div class='mb-3'>
                    <textarea class='form-control' placeholder='Description' name='descriptionInput' rows='3'></textarea>
                </div>";
    }

    private function createPrivacyInput() {
        return "<div class='mb-3'>
                    <select class='form-select' name='privacyInput'>
                        <option selected>Privacy</option>
                        <option value='0'>Private</option>
                        <option value='1'>Public</option>
                    </select>
                </div>";
    }

    private function createCategoriesInput() {
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='mb-3'>
                    <select class='form-select' name='categoryInput'>
                        <option selected>Categories</option>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $name = $row["name"];

            $html .= "<option value='$id'>$name</option>";
        }

        $html .= "</select>
                </div>";

        return $html;

    }

    private function createUploadButton() {
        return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
    }
}
?>