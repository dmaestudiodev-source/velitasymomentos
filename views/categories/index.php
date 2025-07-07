<?php require_once __DIR__ . '/../partials/header.php'; ?>

<h1 class="mb-4">Categorías</h1>

<a href="index.php?controller=category&action=create" class="btn btn-outline-secondary mb-3">+ Agregar nueva categoría</a>

<?php if (!empty($categories)) : ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>categoría</th>
                <th width="20%">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['id'] ?></td>
                    <td><?= htmlspecialchars($category['name']) ?></td>
                    <td>
                        <a href="index.php?controller=category&action=edit&id=<?= $category['id'] ?>" class="btn btn-outline-secondary">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-warning">No se encontraron categorías.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
