<?php
class Rss{
    private function getEliteById($tid) {
        $total = $this->ctx->base->oldAdmin->tieba->getTieba($tid)->elite->getPostCount();
        $pids = $this->ctx->base->oldAdmin->tieba->redisTiebaEliteProvider->getPosts($tid, 0, $total);
        $list = array();
        foreach ($pids as $pid) {
            $post = $this->ctx->base->oldAdmin->tieba->getPost($pid);
            $p_content = $post->editor->content;
            $p_content = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f\x7f]/','', $p_content);
            $title = $post->editor->title;
            $title = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f\x7f]/','', $title);
            $pics = $this->getOriginImgUrl($post->editor->pics);
            $list[] = array(
                'title' => preg_replace('/&/','&amp;',  $title),
                'content' => preg_replace('/&/','&amp;',  $p_content),
                'pubDate' => date(DATE_RSS),
                'pics'   => $pics,
                'pid'   =>  $pid,
            );
        }
        return $list;
    }
}
