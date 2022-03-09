<?php
    if( isset($data['tag']) ) { $tag = $data['tag']; }
    $tagList = $data['tagList'];
?>
<div id="main-content" class="container-fluid">
    <div class="row">
        <div class=" col col-4">
            <div class="left-side">
                <form action="<?php echo getConfig('base_path')?>/tag/new" method="post">
                    <div class="input-group">
                        <label for="tag_name">Tag name:</label>
                        <input type="text" name="tag_name" id="tag_name">
                    </div>
                    <div class="input-group">
                        <label for="tag_desc">Tag description</label>
                        <textarea name="tag_desc" id="tag_desc" cols="30" rows="10"></textarea>
                    </div>
                    <div class="input-group">
                        <input type="submit" class="button button-blue" name="create_tag_form" value="Create">
                    </div>
                </form>
            </div>
        </div>
        <div class="col col-8">
            <div class="right-side">
                <table class="table" style="width: 100%">
                    <thead>
                        <div><h2>Tags List</h2></div>
                        <div class="control-bar">
                            <form action="">
                                <div class="row">
                                    <div class="col">
                                        <div class="sort-by">
                                            <span>Soft By:</span>
                                            <select name="soft_by" id="">
                                                    <option value="">ID</option>
                                                    <option value="">Name</option>
                                                    <option value="">Date</option>
                                                    <option value="">Count</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col f-grow-0">
                                        <div class="search">
                                            <input type="text" name="search" id="">
                                            <input type="submit" class="button button-blue" value="filter">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                slug
                            </th>
                            <th>
                                Count
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                        <?php
                            foreach($tagList as $tag) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $tag['name'];?>
                                        </td>
                                        <td>
                                            <?php echo $tag['slug'];?>
                                        </td>
                                        <td>
                                            Chưa liên kết
                                        </td>
                                        <td class="row">
                                            <a href="<?php echo getConfig('base_path')?>/tag/edit/<?php echo $tag['id']?>" class="col button button-blue">Edit</a>
                                            <form class="col" action="<?php echo getConfig('base_path')?>/tag/delete/<?php echo $tag['id']?>" method="post">
                                                <input type="hidden" class="button button-red" value="<?php echo $tag['id']?>">
                                                <input type="submit" class="button button-red" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                            }   
                        ?>
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>