<?php
function getEngineName($id, $arr)
{
  foreach ($arr as $el) {
    if ($el["id"] == $id)
      return $el["name"];
  }

  return null;
}