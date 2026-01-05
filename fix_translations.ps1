$viewPath = "c:\Users\miros\tnm-web\resources\views"
$files = Get-ChildItem -Path $viewPath -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = [System.IO.File]::ReadAllText($file.FullName, [System.Text.Encoding]::UTF8)
    $newContent = $content -replace "'mesage\.", "'messages."
    # Also replace the __('mesage. pattern
    $newContent = $newContent -replace "__\('mesage\.", "__('messages."
    [System.IO.File]::WriteAllText($file.FullName, $newContent, [System.Text.Encoding]::UTF8)
    Write-Host "Fixed: $($file.Name)"
}

Write-Host "All files updated!"
