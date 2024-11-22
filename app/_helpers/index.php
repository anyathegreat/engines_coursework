<?php
function getEngineName($id, $arr)
{
  foreach ($arr as $el) {
    if ($el["id"] == $id)
      return $el["name"];
  }

  return null;
}

function getNearbyPageNumbers($currentPage, $totalPages)
{
  $pageNumbers = [];

  if ($totalPages <= 1) {
    return [1]; // Если всего одна страница, возвращаем ее
  }

  // Устанавливаем начальные и конечные значения
  $start = max(1, $currentPage - 2);
  $end = min($totalPages, $currentPage + 2);

  // Убедимся, что у нас есть ровно 5 страниц
  if ($end - $start + 1 < 5) {
    if ($end < $totalPages) {
      // Если можно увеличить конец
      $end = min($totalPages, $end + (5 - ($end - $start + 1)));
    }
    if ($start > 1) {
      // Если можно уменьшить начало
      $start = max(1, $start - (5 - ($end - $start + 1)));
    }
  }

  // Создаем массив с номерами страниц
  for ($i = $start; $i <= $end; $i++) {
    $pageNumbers[] = $i;
  }

  return $pageNumbers;
}