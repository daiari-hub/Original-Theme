document.addEventListener('DOMContentLoaded', function() {
    const toggleSwitch = document.createElement('button');
    toggleSwitch.textContent = 'ダークモード';
    toggleSwitch.style.position = 'fixed';
    toggleSwitch.style.top = '10px';
    toggleSwitch.style.right = '10px';
    toggleSwitch.style.padding = '10px';
    toggleSwitch.style.backgroundColor = '#0073aa';
    toggleSwitch.style.color = '#ffffff';
    toggleSwitch.style.border = 'none';
    toggleSwitch.style.borderRadius = '5px';
    toggleSwitch.style.cursor = 'pointer';

    document.body.appendChild(toggleSwitch);

    toggleSwitch.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        if (document.body.classList.contains('dark-mode')) {
            toggleSwitch.textContent = 'ライトモード';
        } else {
            toggleSwitch.textContent = 'ダークモード';
        }
    });
});