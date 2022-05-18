const container = document.getElementById("roomLine_container");
document.getElementById("add_bed").addEventListener("click", () => {
  const li = document.createElement("li");
  li.innerHTML = container.dataset.prototype.replace(
    /__name__/g,
    container.dataset.index
  );
  li.querySelector(".remove_bed").addEventListener("click", () => {
    li.remove();
  });
  container.dataset.index += 1;
  container.appendChild(li);
});

const existing_beds = document.getElementsByClassName("remove_bed");
for (let existing_bed of existing_beds) {
  existing_bed.addEventListener("click", () => {
    existing_bed.parentElement.remove();
  });
}
