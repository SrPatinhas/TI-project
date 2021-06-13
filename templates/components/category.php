<!--  Displays a select box of all the categories returned -->

<div class="mb-3">
    <label for="select_category" class="form-label">Category</label>
    <select id="select_category" class="form-select" name="category_id" required>
        <option value="">Select an option</option>
        <?php foreach($categories as $item){ ?>
            <option value="<?=$item["id"]; ?>" <?=($selected == $item["id"] ? 'selected': '') ?> ><?=$item['name']; ?></option>
        <?php } ?>
    </select>
</div>