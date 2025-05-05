let editor;

window.onload = function () {
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/pgsql");

    editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        // enableLiveAutocompletion: true,
        fontSize: "12pt"
    });

    // Prevent Copy/Paste (CTRL+C/CRTL+V)
    // editor.commands.addCommand({
    //     name: "breakTheEditor",
    //     bindKey: "ctrl-c|ctrl-v|ctrl-x|ctrl-shift-v|shift-del|cmd-c|cmd-v|cmd-x|mousedown",
    //     exec: function() {}
    // });

    // Prevent Right Click On Editor
    editor.container.addEventListener("contextmenu", function(e) {
        e.preventDefault();
        // alert("!!");
        return false;
    }, false);
};
